@extends('layouts.frontend')

@section('content')
    <style>
        .control-label {
            font-family: Montserrat-light;
        }
    </style>
    {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">--}}
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" ></script>
    <div class="container-fluid padding0">
        <div class="div-auth-register div-portfolios-rect" id="home" >
            <div class="container" style="padding-bottom: 300px;">
                <div class="panel panel-default">
                    <div class="div-panel-heading">
                        PORTFOLIOS
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
