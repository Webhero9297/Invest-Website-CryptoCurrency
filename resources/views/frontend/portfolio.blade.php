@extends('layouts.frontend')

@section('content')
    <style>
        .control-label {
            font-family: Montserrat-light;
        }
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
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" ></script>
    <div class="container-fluid padding0">
        <div class="div-auth-register div-portfolios-rect" id="home" >
            <div class="container" style="padding-bottom: 200px;">
                <div class="panel panel-default">
                    <div class="div-panel-heading">
                        PORTFOLIOS
                        &nbsp;&nbsp;&nbsp;
                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for name" title="Type in a name">
                    </div>
                    <div class="panel-body panel-table">
                        <table class="table table-bordered" id="example">
                            <thead>
                            <tr>
                                <th class="td-cell">#</th>
                                <th class="td-cell">Name</th>
                                <th class="td-cell">
                                    Invested Capital
                                    <span class="span-sort" data-sort="invest">
                                        <i class="fa fa-sort-amount-asc"></i>
                                    </span>
                                </th>
                                <th class="td-cell">
                                    Current Value
                                    <span class="span-sort" data-sort="capital">
                                        <i class="fa fa-sort-amount-asc"></i>
                                    </span>
                                </th>
                                <th class="td-cell">
                                    Profit/Loss(Total)
                                    <span  class="span-sort" data-sort="profit">
                                        <i class="fa fa-sort-amount-asc"></i>
                                    </span>
                                </th>
                                <th class="td-cell"></th>
                            </tr>
                            </thead>
                            <tbody id="tbody_content">
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
{{--    <script src="{{ asset('./js/frontend/editprofile.js') }}"></script>--}}
    <script src="{{ asset('./js/frontend/portfolio.js') }}"></script>
@endsection
