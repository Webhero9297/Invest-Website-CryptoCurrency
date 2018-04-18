@extends('layouts.frontend')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" />
<script src="{{ asset('./assets/jsLib/datatable/jquery.datatable.js') }}" ></script>
<script src="{{ asset('./assets/jsLib/datatable/datatable.bootstrap.js') }}" ></script>
<style>
    .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        width: 100%;
        border:0;
        border-radius:0;
        height: 420px;
        background-color: rgb(8,8,8);
    }
    .card:hover {
        box-shadow: 2px 3px 4px 0 rgba(255,255,255,0.2);
    }
    .article-container {
        padding: 2px 16px;
    }
    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }
    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 38%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
    }
    .article-container:hover .image {
        opacity: 0.3;
    }
    .article-container:hover .middle {
        opacity: 1;
    }
    .div-bottom {
        padding-left: 15px;
        padding-right: 15px;
    }
    .span-float-right {
        float: right;
    }
    .div-news-title {
        max-height: 72px;
        height: 70px;
        overflow: hidden;
        font-size: 14px;
        font-family: Montserrat-Light;
    }
    .div-content-bottom {
        bottom: 0;
    }
    .a-view-detail{
        line-height: 20px;
        width:300px;
        height: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 24px;
        font-family: Montserrat-Light;
    }
    .card a {
        color: white;
    }
    .card a:hover {
        color: white;
    }
</style>
<script>
</script>
    <div class="container-fluid padding0">
        <div class="div-auth-register" id="home" style="padding-top:100px;">
            <div class="container" style="padding-bottom: 50px;">
                <div class="panel panel-default" style="border:none;background: transparent;">
                    <div class="div-panel-heading" style="">
                        News
                        &nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="panel-body panel-table">
                        @if ( $news_data )
                        <div class="row">
                            @foreach( $news_data as $news )
                            <div class="col-xs-12 col-sm-6 col-md-4" style="padding-bottom:15px;">
                                <div class="card">
                                    <div class="article-container">
                                        <img src="{{ $news['imageurl'] }}" alt="Avatar" class="image" style="width:100%">
                                        <div class="middle">
                                            <a href="{{ $news['url'] }}" class="a-view-detail color-black" target="_blank">
                                                View More
                                            </a>
                                        </div>
                                    </div>
                                    <div class="div-bottom">
                                        <div class="title div-news-title">
                                            <a href="{{ $news['url'] }}" class="title div-news-title" target="_blank">{{ $news['title'] }}</a>
                                        </div>
                                        <div class="div-content-bottom">
                                            <span class="title">By <b>{{ $news['source_info']->name }}</b></span>
                                            <span class="title span-float-right">{{ $news['diff_time'] }} ago</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
