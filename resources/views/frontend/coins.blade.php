@extends('layouts.frontend')

@section('content')
    <style>
        .control-label {
            font-family: Montserrat-light;
        }

        .here {
            background: url( {{ asset('./assets/images/icon/arrow_up_white.png') }}) no-repeat!important;
            background-size: 18px!important;
            background-position: calc(100% - 10px) center!important;
            background-repeat: no-repeat!important;
            background-color: transparent;
            width: 140px!important;
            color: white!important;
            border-color: white!important;
            display: inline;
            margin-right: 10px;
            margin-top: 0px;
        }
        .a-refresh-tag {
            margin-right: 0;
            margin-left: 10px;
            position: relative;
            top: -10px;
            cursor: pointer;
        }
        .a-refresh-tag:hover {
            color: gold!important;
        }
        .a-gold:hover {
            color: gold!important;
        }

        /***************************************  Custom select box start  *********************************************/
        @import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
        /*@import url(font-icomoon.css);*/
        @import url(https://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css);
        /** Custom field plugin **/
        /* SELECT */
        .selectCF{
            margin:0;
            padding:0;
            display:inline-block;
            position:relative;
            font-family: Montserrat-light;
            font-size:17px;
            font-weight:bold;
        }
        .selectCF li{
            list-style:none;
            cursor: pointer;
            perspective: 900px;
            -webkit-perspective: 900px;
            text-align: left;
        }
        .selectCF > li{
            position:relative;
            font-size:0;
        }
        .selectCF span{
            display:inline-block;
            height:45px;
            line-height:45px;
            color:#FFF;
            z-index:1;
        }
        .selectCF .arrowCF{
            transition: .3s;
            -webkit-transition: .3s;
            width:45px;
            text-align:center;
            vertical-align: top;
            font-size:17px;
            border: 1px solid #FFFFFF55;
        }
        .selectCF .titleCF{
            padding: 0 10px 0 20px;
            font-size:16px;
            font-family: Montserrat-light;
            font-weight:400;
            overflow:hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            border: 1px solid #FFFFFF55;
        }
        .selectCF .searchCF{
            padding: 0 10px 0 20px;
            border-left: dotted 1px #0297bf;
            position: absolute;
            top:0;
            right:0;
            z-index:-1;
        }
        @keyframes searchActive {
            from{ transform: rotateY(180deg) }
            to{ transform: rotateY(0deg); }
        }@-moz-keyframes searchActive {
             from{ transform: rotateY(180deg) }
             to{ transform: rotateY(0deg); }
         }
        @-webkit-keyframes searchActive {
            from{ -webkit-transform: rotateY(180deg) }
            to{ -webkit-transform: rotateY(0deg); }
        }
        .searchActive .searchCF{
            z-index:1;
            animation: searchActive 0.3s alternate 1;
            -moz-animation: searchActive 0.3s alternate 1;
            -webkit-animation: searchActive 0.3s alternate 1;
        }
        .searchActive .titleCF{
            opacity:0;
        }
        .selectCF .searchCF input{
            font-family: 'Neucha', cursive;
            line-height:45px;
            border:none;
            padding:0;
            margin:0;
            width:100%;
            height:100%;
            background:transparent;
            font-size:17px;
        }
        .selectCF .searchCF input:active, .selectCF .searchCF input:focus{
            box-shadow:none;
            border:none;
            outline: none;
        }
        .selectCF li ul{
            display:none;
            position:absolute;
            top:100%;
            left:0;
            padding: 0 !important;
            width:100%;
            max-height: 255px;
            overflow-y: auto;
            transition: .2s;
            -webkit-transition: .2s;
            z-index:2;
            background: #0297bf;

        }
        .selectCF li ul li{
            padding:9px 0 9px 20px;
            border-bottom: 1px solid rgba(240,240,240,.9);
            font-weight:normal;
            font-size:14px;
            transition: .2s;
            -webkit-transition: .2s;
            overflow:hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .selectCF li ul li:hover{
            background: #24b9bf;
            color:#FFF;
        }
        .selectCF .selected{
            background: #12a8bf;
            border-bottom: solid 1px #bf3259;
            color:#FFF;
        }
        .selectCF li ul li:last-child{
            border-bottom: none;
        }
        .onCF .arrowCF{
            transform: rotate(90deg);
            -webkit-transform: rotate(90deg);
        }
        @-moz-keyframes effect1 {
            from{ transform: translateY(15px); opacity:0; }
            to{ transform: translateY(0px); opacity:1; }
        }
        @-webkit-keyframes effect1 {
            from{ -webkit-transform: translateY(15px); opacity:0; }
            to{ -webkit-transform: translateY(0px); opacity:1; }
        }
        .onCF li ul{
            display:block;
            -moz-animation: effect1 0.3s alternate 1;
            -webkit-animation: effect1 0.3s alternate 1;
        }

        /***************************************  Custom select box end    *********************************************/

        #myInput {
            background-image: url({{ asset('./assets/images/icon/searchicon.png') }});
            background-position: 10px 8px;
            background-repeat: no-repeat;
            font-size: 16px;
            padding: 4px 10px 4px 40px;
            border: 1px solid #ddd;
            margin-top: -17px;
            margin-bottom: 1px;
            background-color: #0297bf;
            color: white;
        }
        input::-webkit-input-placeholder {
            color: #fff;
        }
        input:focus::-webkit-input-placeholder {
            color: gold;
            border-color: gold;
        }

        /* Firefox < 19 */
        input:-moz-placeholder {
            color: #fff;
        }
        input:focus:-moz-placeholder {
            color: gold;
            border-color: gold;
        }

        /* Firefox > 19 */
        input::-moz-placeholder {
            color: #fff;
        }
        input:focus::-moz-placeholder {
            color: gold;
            border-color: gold;
        }

        /* Internet Explorer 10 */
        input:-ms-input-placeholder {
            color: #fff;
        }
        input:focus:-ms-input-placeholder {
            color: gold;
            border-color: gold;
        }
    </style>
{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />--}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" />
<script src="{{ asset('./assets/jsLib/datatable/jquery.datatable.js') }}" ></script>
<script src="{{ asset('./assets/jsLib/datatable/datatable.bootstrap.js') }}" ></script>
<script>
    var totalCount = <?php echo $totalCount; ?>;
</script>
    <div class="container-fluid padding0">
        <div class="div-auth-register" id="home" style="padding-top:100px;">
            <div class="container" style="padding-bottom: 50px;">
                <div class="panel panel-default" style="border:none;background: transparent;">
                    <div class="div-panel-heading" style="">
                        COINS
                        &nbsp;&nbsp;&nbsp;
                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for coins" title="Type in a name">
                        <div style="display:inline;float:right;margin-top:-15px;">
                            <select id="currency" class="select">
                                <option value="USD">USD</option>
                                <option value="CAD">CAD</option>
                                <option value="AUD">AUD</option>
                                <option value="GBP">GBP</option>
                                <option value="EUR">EUR</option>
                            </select>
                            <a class="a-white a-refresh a-refresh-tag" onclick="doOnLoadLiveChart()">
                                <i class="fa fa-refresh" ></i>
                            </a>
                        </div>

                    </div>
                    <div class="panel-body panel-table">
                        <table id="coin_table" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" style="width:100%;margin-top: -5px!important;">
                            <thead>
                            <tr>
                                <th class="td-cell td-grey" width="120px">RANK</th>
                                <th class="td-cell td-grey" width="22%">Name</th>
                                <th class="td-cell td-grey" width="22%">Current Price</th>
                                <th class="td-cell td-grey" width="22%">Market Capital</th>
                                <th class="td-cell td-grey">24H Change %</th>
                            </tr>
                            </thead>
                            <tbody id="tbody_coin_live_data" class="text-center">
                            </tbody>
                            <tfoot id="tfoot">
                                <tr>
                                    <td align="center" colspan="5">
                                        <div class="page-btn-group text-center">
                                            @if ($totalCount>0)
                                                @for( $count = 0; $count<$totalCount; $count++ )
                                                    <div class="btn-page {{ $count==0 ? "btn-page-active" : "" }}" page-pos="{{ $count }}" >{{ $count+1 }}</div>
                                                @endfor
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="{{ asset('./js/frontend/coins.js') }}"></script>
@endsection
